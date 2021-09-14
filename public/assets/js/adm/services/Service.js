export class Service{constructor(baseUrl){this.baseUrl='http://'+baseUrl;this.headersGet={method:'GET',}}
async get(path,headers=this.headersGet){try{const response=await fetch(this.baseUrl+path,headers);if(!response.ok){throw new Error('error')}
return response.json()}catch(e){this.error(e)}}
async post(path,headers){try{const response=await fetch(this.baseUrl+path,headers);return response.json()}catch(e){this.error(e)}}
error(e){console.log('deu error');return e}
async paginator(path,pageValue,limitValue){let limit=limitValue?`&limit=${limitValue}`:'';let page=pageValue?`?page=${pageValue}`:'';return await this.get(path+page+limit)}}