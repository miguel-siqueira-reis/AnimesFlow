import {TableUtilsController} from "../Utils/Table/TableUtilsController.js";
import {ListEpisodios} from "../model/episodios/ListEpisodios.js";
import {EpisodioService} from "../services/EpisodioService.js";
import {EpisodioView} from "../view/EpisodioView.js";

export class EpisodioController extends TableUtilsController {
  constructor(id = false) {
    super('episodios', new ListEpisodios(), new EpisodioService(), new EpisodioView('episodios'));
    this.tempId = id;
  }

  async createEpTableById(id = this.tempId) {
    this.tempId = id;
    await this.createById(this.tempId);
    await this.eventLimit();
    await this.eventPages();
    await this.eventSearch();
  }

  async connectionBySearch() {
    this.json = await this.service.search(this.searchText, this.tempId, this.page, this.limit) || false;
    this.list.set(this.json['data'] || false);
    this.error = this.json['error'];
  }
}