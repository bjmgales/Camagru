import { USERNAME } from './const/const.js';
import { fetchMe } from './me.js';
import { fillInnerHtml } from './utils.js';

const userData = await fetchMe();

const welcomeDiv = document.querySelector('#welcome-user');

fillInnerHtml(welcomeDiv, `Welcome ${userData[USERNAME]}! Feels great to see you here!`);
