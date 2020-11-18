jQuery(document).ajaxComplete(function (event, xhr, settings) {
    let data = settings.data;
    let param = new URLSearchParams(data);
    //Add
    if (param.get('action') === 'vc_edit_form' && param.get('tag') === 'instagram-feedhub') {
        console.log(data);
    }
});

