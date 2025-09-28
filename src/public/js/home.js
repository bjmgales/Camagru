import { USERNAME } from './const/const.js';
import { fetchMe } from './fetchService/api.js';
import { fillInnerHtml } from './utils.js';



const cameraMode = () =>{
  camBtn.classList.add('selected');
  galleryBtn.classList.remove('selected')
}

const galleryMode = () =>{
  galleryBtn.classList.add('selected');
  camBtn.classList.remove('selected')
}

const camBtn = document.querySelector('.galleryBtn')
const galleryBtn = document.querySelector('.cameraBtn');

camBtn.addEventListener('click', cameraMode);
galleryBtn.addEventListener('click', galleryMode)



const welcomeUser = async () => {
  try {
    const userData = await fetchMe();
    const usernameSpan = document.querySelector('#username-span');
    console.log(usernameSpan);
    fillInnerHtml(usernameSpan, `${userData[USERNAME]}`);
  } catch {
    window.location.href = '/';
  }
};

welcomeUser();

