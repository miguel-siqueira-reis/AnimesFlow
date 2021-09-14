import{Service}from './Service.js';export class AnimeService extends Service{constructor(){super('localhost:8080/api/animes')}
async getByPage(page,limit){return await this.get(`?page=${page}&limit=${limit}`)}
async getAll(){return await this.get()}
async search(name,page,limit){return await this.paginator(`/search/${name}`,page,limit)}}