//   === simulateEvent for ELEMENTOR === //
let _timeOut = null;

function simulateEvent(event) {
  var evt = document.createEvent('Event');
  evt.initEvent(event, true, true);
  var cb = document.querySelector('input[data-setting="instafeedhub_input"]');
  var canceled = !cb.dispatchEvent(evt);
}

function hookElementor() {
  elementor.hooks.addAction('panel/open_editor/widget/instafeedhub', function (panel, model, view) {
    var $element = view.$el.find('.wil-instagram-shopify');
    if (_timeOut) clearTimeout(_timeOut);
    if ($element) {
      let instaID = '';
      if ($element[0]) {
        instaID = $element[0].getAttribute('data-id');
      }
      _timeOut = setTimeout(() => {
        init(instaID);
      }, 1000);
    }
  });
}
//    ===
jQuery(document).ajaxComplete(function (event, xhr, settings) {
  window.addEventListener('message', event => {
    if (event.data.type && event.data.type.includes('FE_INSTA_BACKERY_DATA')) {
      const input = document.querySelector('input[data-setting="instafeedhub_input"]');
      input.value = event.data.payload.id;
      simulateEvent('change');
      simulateEvent('input');
    }
  });

  setTimeout(() => {
    hookElementor();
  }, 3000);

  //   let param, data, keys, vals, actions, action;
  //   const input = document.querySelector('input[data-setting="instafeedhub_input"]');

  //   if (!!settings.data) {
  //     param = new URLSearchParams(settings.data);
  //     actions = JSON.parse(param.get('actions'));
  //     if (!!actions) {
  //       keys = Object.keys(actions);
  //       vals = keys.map(function (item) {
  //         return actions[item];
  //       });
  //       if (!!vals[0].data && !!vals[0].data.data) {
  //         data = vals[0].data.data;
  //         //Add
  //         if (data.widgetType === 'instafeedhub') {
  //           init();
  //         }
  //       }
  //     }
  //   }
});

function init(instaID) {
  const input = document.querySelector('input[data-setting="instafeedhub_input"]');
  if (!input) return;
  input.setAttribute('disabled', true);
  window.InstafeedHubTokens = { ...InstafeedHubTokens, args: { id: instaID } };

  // === postMessage to reactjs
  window.postMessage({ type: 'ADD_INSTA_ELEMENTOR', payload: { instaID } }, location.origin);
}
