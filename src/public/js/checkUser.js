import { apiRequest } from './utils/api.js';

const checkUser = async () => {
  const data = await apiRequest('me');
  if (data['authenticated'] == true) {
    window.location.href = '/';
  } else {
    window.location.href = '/login';
  }
};

checkUser();
