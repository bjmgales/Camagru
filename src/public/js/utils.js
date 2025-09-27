export const fillInnerHtml = (element, text, color) => {
  element.innerHTML += text;
  if (color) element.style.color = color;
};
