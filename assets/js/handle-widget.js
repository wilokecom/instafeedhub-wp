jQuery(document).ajaxComplete(function (event, xhr, settings) {
    let data = settings.data;
    let Params = new URLSearchParams(data);
    if (Params.get('action') == 'save-widget' && Params.get('id_base') == 'instagram-feed') {
        //Add
        if (Params.get('add_new') == 'multi') {
        }

        //Delete
        if (!!Params.get('delete_widget')) {
            //Something here
        }
    }
});