import env from "@/.env.js";

let url = env.url;
let urlApi = env.urlApi;
let auth = env.auth;
let locales = ['ua', 'ru', 'pl'];

export default {
  url,
  urlApi,
  auth,
  locales
};
