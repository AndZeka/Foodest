import http from "../http-common.js";

class EmailDataService {
  getAll() {
    return http.get("/emails");
  }

  create(data) {
    return http.post("/emails", data);
  }

  findByName(name) {
    return http.get(`/emails?name=${name}`);
  }
}

export default new EmailDataService();