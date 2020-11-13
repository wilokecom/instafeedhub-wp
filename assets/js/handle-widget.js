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
          buttonID: 'widget-' + newId + '-button',
          instagramID: '',
          widgetID: newId,
        },
      };

      setTimeout(() => {
        window.postMessage(
          {
            type: 'ADD_INSTA_WIDGET',
            payload: {
              widgetID: newId,
            },
          },
          location.origin,
        );
      }, 1000);
    }

    //Delete
    if (!!param.get('delete_widget')) {
      //Something here
      console.log(222, '__delete widgetId:', { id: param.get('widget-id') });
      const idDeleted = param.get('widget-id');

      const newKeys = Object.keys(window.instafeedHubElements).filter(item => item !== idDeleted);

      const newInstaObj = newKeys.reduce((obj, item) => {
        return {
          ...obj,
          [item]: window.instafeedHubElements[item],
        };
      }, {});

      window.instafeedHubElements = newInstaObj;

      setTimeout(() => {
        window.postMessage(
          {
            type: 'DELETE_INSTA_WIDGET',
            payload: {
              widgetID: idDeleted,
            },
          },
          location.origin,
        );
      }, 1000);
    }
  }
});
