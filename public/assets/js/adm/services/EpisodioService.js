import{Service}from "./Service.js";export class EpisodioService extends Service{constructor(){super('localhost:8080/api/episodes')}
async getAll(){return await this.get()}
async getByPage(page,limit){return await this.get(`?page=${page}&limit=${limit}`)}
async getById(id,pageValue=!1,limitValue=!1){let limit=limitValue?`&limit=${limitValue}`:'';let page=pageValue?`&page=${pageValue}`:'';return await this.get('?id_temporada='+id+page+limit)}
async search(name,id,pageValue,limitValue){let limit=limitValue?`&limit=${limitValue}`:'';let page=pageValue?`&page=${pageValue}`:'';return await this.get(`/search/${name}?id_temporada=${id+page+limit}`)}}