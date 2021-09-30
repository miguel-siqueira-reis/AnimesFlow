import{Service}from "./Service.js";export class TemporadaService extends Service{constructor(){super('localhost:8080/api/seasons')}
async getByPage(page,limit){return await this.get(`?page=${page}&limit=${limit}`)}
async getAll(){return await this.get()}
async getById(id,pageValue=!1,limitValue=!1){let limit=limitValue?`&limit=${limitValue}`:'';let page=pageValue?`&page=${pageValue}`:'';return await this.get('?id_anime='+id+page+limit)}}