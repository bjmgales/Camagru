import { USERNAME } from './const/const.js';
import { fetchMe } from './fetchService/api.js';
import { fillInnerHtml } from './utils.js';

const welcomeUser = async () => {
  const userData = await fetchMe();
  const welcomeDiv = document.querySelector('#welcome-user');
  console.log(welcomeDiv)
  fillInnerHtml(welcomeDiv, `Welcome ${userData[USERNAME]}! Feels great to see you here!`);
};

welcomeUser();
