jQuery(document).ajaxComplete(function (event, xhr, settings) {
    let data = settings.data;
    let param = new URLSearchParams(data);
    if (param.get('action') === 'save-widget' && param.get('id_base') === 'instagram-feed') {
        //Add
        if (param.get('add_new') === 'multi') {
        }

        //Delete
        if (!!param.get('delete_widget')) {
            //Something here
        }
    }
});