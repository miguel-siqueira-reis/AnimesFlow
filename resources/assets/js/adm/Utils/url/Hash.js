export class Hash {
  constructor(nameTable) {
    this.nameTable = nameTable.toLowerCase();
    this.load();
    console.log(this.params)
  }

  load() {
    this.params = {};
    let hashStr = window.location.hash;
    if (!hashStr) return;
    hashStr = hashStr.substring(1, hashStr.length);
    const hashArray = hashStr.split('&');

    hashArray.forEach(hashElement => {
      const keyVal = hashElement.split('=');
      this.params[decodeURIComponent(keyVal[0])] = (typeof keyVal[1] != "undefined") ? decodeURIComponent(keyVal[1]) : keyVal[1];
    })
  }

  has(key) {
    return this.params.hasOwnProperty(decodeURIComponent(key));
  }

  get(key) {
    if (!this.has(key)) return false;
    return this.params[decodeURIComponent(key)];
  }

  set(key, value) {
    if(key && value === '') return this.remove(key);
    this.params[decodeURIComponent(key)] = value;
    this.push();
  }

  push() {
    const hashBuilder = [];
    for (let key in this.params) if(this.params.hasOwnProperty(key)) {
      key = decodeURIComponent(key)
      const value = decodeURIComponent(this.params[key]);
      if (value !== "undefined") {
        hashBuilder.push(key + '=' + value);
      }
    }
    window.location.hash = hashBuilder.length > 1 ? hashBuilder.join("&") : hashBuilder.toString().replaceAll(',', '');
  }

  remove(key) {
    delete this.params[key];
    this.push();
  }

  getPage() {
    const value = this.get(this.nameTable+'page');
    if ((!this.has(this.nameTable+'page')) && (!parseInt(value))) return false;
    return parseInt(value);
  }

  setPage(value) {
    if (!parseInt(value)) return false;
    this.setAny('page', parseInt(value));
  }

  getLimit() {
    const value = this.get(this.nameTable+'limit');
    if ((!this.has(this.nameTable+'limit')) && (!parseInt(value))) return false;
    return parseInt(value);
  }

  setLimit(value) {
    if (!parseInt(value)) return false;
    this.setAny('limit', parseInt(value));
  }

  getSearchText() {
    return this.getAny('searchtext');
  }

  setSearchText(value) {
    this.setAny('searchtext', value)
  }

  getEventClick() {
    return this.getAny('eventclick');
  }

  setEventClick(value) {
    this.setAny('eventclick', value);
  }

  getAny(param) {
    if (!this.has(this.nameTable+param)) return false;
    return this.get(this.nameTable+param);
  }

  setAny(name, value) {
    this.set(this.nameTable+name, value);
  }
}