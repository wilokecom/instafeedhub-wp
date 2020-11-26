jQuery(document).ajaxComplete(function (event, xhr, settings) {
  let param, data, keys, vals, actions, action;
  const input = document.querySelector('input[data-setting="instafeedhub_input"]');

  input && input.addEventListener('click', init);

  if (!!settings.data) {
    param = new URLSearchParams(settings.data);
    actions = JSON.parse(param.get('actions'));
    if (!!actions) {
      keys = Object.keys(actions);
      vals = keys.map(function (item) {
        return actions[item];
      });
      if (!!vals[0].data && !!vals[0].data.data) {
        data = vals[0].data.data;
        //Add
        if (data.widgetType === 'instafeedhub') {
          console.log('aaaaa');
          init();
        }
      }
    }
  }
});

function init() {
  const input = document.querySelector('input[data-setting="instafeedhub_input"]');

  if (!input) return;
  const instaID = input.getAttribute('value');
  window.InstafeedHubTokens = { ...InstafeedHubTokens, args: { id: instaID } };

  // === postMessage to reactjs
  window.postMessage({ type: 'ADD_INSTA_ELEMENTOR', payload: { instaID } }, location.origin);

  // === revice to reactjs
  window.addEventListener('message', event => {
    if (event.data.type && event.data.type.includes('FE_INSTA_BACKERY_DATA')) {
      input.setAttribute('value', event.data.payload.id);
    }
  });
}
