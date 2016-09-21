if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}
Array.prototype.diff = function(a) {
    return this.filter(function(i){return a.indexOf(i) < 0;});
};

pistol88.modificationconstruct = {
    modifications: null,
    init: function() {
<<<<<<< HEAD
        $(document).on('change', '.product-add-modification-form .filters select', this.generateName);
=======
        $(document).on('change', '.product-modification-update .filters select', this.generateName);
>>>>>>> dde34cb56543c6bbaf1c11173ea4709f79f24b6e
        
        $(document).on("beforeChangeCartElementOptions", function(e, options) {
            pistol88.modificationconstruct.setModification(options);
        });
    },
    setModification: function(options) {
        if(pistol88.modificationconstruct.modifications) {
            var cartOptions = options;
            $.each(pistol88.modificationconstruct.modifications, function(i, m) {
                var options = [];
                $.each(cartOptions, function(i, co) {
                    options.push(co);
                });

                var filter_value = $.makeArray(m.filter_value);

                if(options.length == filter_value.length) {
                    var result = options.diff(filter_value);
                    if(result.length == 0) {
                        if(m.price > 0) {
                            $('.pistol88-shop-price-'+m.product_id).html(m.price);
                            $(document).trigger("shopSetModification", m);
                        }
                    }
                }
            });
        }
    },
    generateName: function() {
        var name = '';
<<<<<<< HEAD
        $('.product-add-modification-form .filters select').each(function(i, el) {
=======
        $('.product-modification-update .filters select').each(function(i, el) {
>>>>>>> dde34cb56543c6bbaf1c11173ea4709f79f24b6e
            var val = $(this).find('option:selected').text();
            if(val) {
                name = name+' '+val;
            }
        });
        
        if(name != '') {
            $('#modification-name').val(name);
        }
    }
}

pistol88.modificationconstruct.init();