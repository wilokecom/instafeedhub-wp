jQuery(document).ajaxComplete(function (event, xhr, settings) {
  let data = settings.data;
  let param = new URLSearchParams(data);
  //Add
  const input = document.querySelector('input[name="vc-instagram-feedhub-input"]');

  input.addEventListener('click', init);

  if (param.get('action') === 'vc_edit_form' && param.get('tag') === 'vc-instagram-feedhub') {
    init();
  }

  function init() {
    if (!input) return;
    const instaID = input.getAttribute('value');
    window.InstafeedHubTokens = { ...InstafeedHubTokens, args: { id: instaID } };

    if (!document.querySelector('#rootBakery')) {
      var node = document.createElement('div');
      node.setAttribute('id', 'rootBakery');
      document.body.appendChild(node);
    }

    // === postMessage to reactjs
    window.postMessage({ type: 'ADD_INSTA_BAKERY', payload: { instaID } }, location.origin);

    // === revice to reactjs
    window.addEventListener('message', event => {
      if (event.data.type && event.data.type.includes('FE_INSTA_BACKERY_DATA')) {
        input.setAttribute('value', event.data.payload.id);
      }
    });
  }
});
