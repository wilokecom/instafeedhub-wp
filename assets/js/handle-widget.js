jQuery(document).ajaxComplete(function (event, xhr, settings) {
  let data = settings.data;
  let param = new URLSearchParams(data);
  if (param.get('action') === 'save-widget' && param.get('id_base') === 'instagram-feed') {
    //Add
    if (param.get('add_new') === 'multi') {
      const newId = param.get('widget-id');
      console.log(111, '__add widgetId:', { id: param.get('widget-id') });
      window.instafeedHubElements = {
        ...window.instafeedHubElements,
        [newId]: {
          buttonID: newId + '-button',
          instagramID: '',
        },
      };
    }

    //Delete
    if (!!param.get('delete_widget')) {
      //Something here
      console.log(222, '__delete widgetId:', { id: param.get('widget-id') });
      const idDeleted = param.get('widget-id');
      const {[idDeleted], ...newIds} = window.instafeedHubElements;
      window.instafeedHubElements = newIds;
    }
  }
});
