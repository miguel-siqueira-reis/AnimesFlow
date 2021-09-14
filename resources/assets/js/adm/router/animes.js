import {AnimeController} from '../Controllers/AnimeController.js';

const $_get = (params) => (new URLSearchParams(window.location.search)).get(params);

const animeController = new AnimeController();

animeController.createAnimeTable();

if($_get('temp')) tempController.createTempTable($_get('temp'));
if($_get('ep')) epController.createEpTable($_get('ep'));
