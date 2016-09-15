if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}

pistol88.modificationconstruct = {
    init: function() {
        $(document).on('change', '.product-modification-update .filters select', this.generateName);
    },
    generateName: function() {
        var name = '';
        $('.product-modification-update .filters select').each(function(i, el) {
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