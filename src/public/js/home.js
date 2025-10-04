import { USERNAME } from './const/const.js';
import { fetchMe } from './fetchService/api.js';
import { fillInnerHtml } from './utils.js';

const cameraMode = () => {
  camBtn.classList.add('selected');
  galleryBtn.classList.remove('selected');
};

const galleryMode = () => {
  galleryBtn.classList.add('selected');
  camBtn.classList.remove('selected');
};

const camBtn = document.querySelector('.galleryBtn');
const galleryBtn = document.querySelector('.cameraBtn');

camBtn.addEventListener('click', cameraMode);
galleryBtn.addEventListener('click', galleryMode);

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

const getCamAccess = async () => {
  const video = document.querySelector('#video-element');
  if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then((stream) => {
        video.srcObject = stream;
        document.querySelector('#webcam-container').style.display = 'flex';
      })
      .catch(() => {
        console.error('Something went wrong...');
        document.querySelector('#upload-container').style.display = 'flex';
      });
  }
};

const fetchOverlays = () => {
  const overlayDiv = document.querySelector('#overlay-gallery');

  const paths = [
    '/uploads/overlays/defaults/elie.png',
    '/uploads/overlays/defaults/manu.png',
    '/uploads/overlays/defaults/franck.png',
  ];

  for (let path of paths) {
    const image = document.createElement('img');
    image.width = 0;
    image.src = path;
    overlayDiv.append(image);
  }
};
welcomeUser();
fetchOverlays();
getCamAccess();

const snapshotClick = () => {
  const audio = new Audio('../sounds/picture.mp3');
  audio.play();

  const video = document.querySelector('#video-element');
  const div = video.parentElement;

  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  div.appendChild(canvas);

  video.style = 'display: none';
  takePictureBtn.style = 'display: none';
};

const takePictureBtn = document.querySelector('#take-snapshot');
takePictureBtn.addEventListener('click', snapshotClick);

const uploadImage = () => {
  const input = document.querySelector('#file-input');

  input.click();

  fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    console.log(file);
  });
};

const uploadDiv = document.querySelector('#upload-div');

uploadDiv.addEventListener('click', uploadImage);
