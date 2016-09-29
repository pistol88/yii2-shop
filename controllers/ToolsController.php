<?php
namespace pistol88\shop\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class ToolsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
        ];
    }
    
    public function actionSync()
    {
        set_time_limit(0);
        $productService = $this->module->getService('product');
        $categoryService = $this->module->getService('category');
		$producerService = $this->module->getService('producer');
        
        $path = $this->module->oneC['importFolder'];
        $importFiles = glob("$path\import*.xml");
        $offerFiles = glob("$path\offers*.xml");
        
        foreach($importFiles as $key => $importFile) {
            $data = simplexml_load_file($importFile);
            $offers = simplexml_load_file($offerFiles[$key]);
            //$this->parseCategory($data->Классификатор->Группы->Группа);
            
            $prices = [];
            foreach($offers->ПакетПредложений->Предложения->Предложение as $offer) {
                $prices[(string)$offer->Ид] = (int)$offer->Цены->Цена->ЦенаЗаЕдиницу;
            }
            
            foreach($data->Каталог->Товары->Товар as $product) {
                $groupId = (string)$product->Группы->Ид;
                
				$category = $categoryService::find()->where(['code' => $groupId])->one();

				$producer = null;
				
				if($product->Изготовитель) {
					if($producerId = (string)$product->Изготовитель->Ид) {
						if(!$producer = $producerService::find(['code' => $producerId])->one()) {
							$producer = new $producerService;
							$producer->name = (string)$product->Изготовитель->Наименование;
							$producer->save();
						}
					}
				}
				
				$code = (string)$product->Ид;
				$amount = (int)$product->БазоваяЕдиница->Пересчет->Единица;
				$name = (string)$product->Наименование;
				
				if(!$shopProduct = $productService::find()->where(['code' => $code])->one()) {
					$shopProduct = new $productService; 
				}

				$shopProduct->amount = $amount;
				$shopProduct->name = $name;
				$shopProduct->code = $code;
				$shopProduct->amount = $amount;

				if($category) {
					$shopProduct->category_id = $category->id;
				}
				if($producer) {
					$shopProduct->producer_id = $producer->id;
				}
				
				$shopProduct->save();

				echo $shopProduct->id.'+';
				
                $shopProduct->setPrice($prices[$shopProduct->code]);
 
				if(!$shopProduct->hasImage() && $image = $product->Картинка) {
                    $image = $path.'/'.$image;
                    $shopProduct->attachImage($image);
				}
            }
        }
    }
    
    private function parseCategory($groups, $parentId = 0)
    {
        $categoryService = $this->module->getService('category');
        
        foreach($groups as $group) {
            $category = new $categoryService; 
            $category->name = (string)$group->Наименование;
            $category->code = (string)$group->Ид;
            $category->parent_id = $parentId;
            $category->save();

            if($subGroups = $group->Группы->Группа) {
                $this->parseCategory($subGroups, $category->id);
            }
        }
    }
    
    public function actions()
    {
        return [
            'upload-imperavi' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'fileparam' => 'file',
                'responseUrlParam'=> 'filelink',
                'multiple' => false,
                'disableCsrf' => true
            ]
        ];
    }
}