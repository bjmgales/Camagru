import { apiRequest } from './api.js';

const logout = async () => {
  await apiRequest('logout');
  window.location.href = '/login';
};

document.querySelector('.logoutButton').addEventListener('click', logout);
