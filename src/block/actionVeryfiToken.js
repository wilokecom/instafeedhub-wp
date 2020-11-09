import Axios from 'axios';
import handleError from '../handleError';

const customAxios = Axios.create({ baseURL: 'https://instafeedhub.com/wp-json/instafeedhub/v1' });

const hanldePostAjaxAccesstockenToServer = (data = {}) => {
  // === ko su dung customAxios ...
  var bodyFormData = new FormData();
  bodyFormData.append('accessToken', data.accessToken);
  bodyFormData.append('refreshToken', data.refreshToken);
  bodyFormData.append('action', 'instafeedhub_save_tokens');

  const config = {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  };
  Axios.post(window.ajaxurl, bodyFormData, config);
};

const getTimeStampModules9 = () => {
  // lay timestap + 1 ngay roi chia cho 9 lay phan nguyen
  const d = new Date();
  const nextDay = d.getTime() + 1000 * 60 * 60 * 24;
  const modulus = nextDay - (nextDay % 9);
  return modulus;
};

async function signin(data) {
  try {
    const response = await customAxios.post('/wp-customer/signin ', {
      ...data,
      variation: 'instafeedhub',
      createdAt: getTimeStampModules9(),
    });

    if (response.status === 200) {
      hanldePostAjaxAccesstockenToServer(response.data);
      return response.data;
    } else {
      return response.status + ' - Some went error!';
    }
  } catch (error) {
    return handleError(error) || response.status + ' - Some went error!';
  }
}

export { signin };
