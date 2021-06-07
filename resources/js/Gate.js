export default class Gate{

    constructor(user){
        this.user = user
    }

    isAdmin(){
        return this.user.type === "admin";
    }

    isRestaurant(){
        return this.user.type === "restaurant";
    }

    isUser(){
        return this.user.type === "user";
    }

    isAdminOrRestaurant(){
        return this.user.type === "admin" || this.user.type === "restaurant";
    }

    isAdminOrUser(){
        return this.user.type === "admin" || this.user.type === "user";
    }

    isRestaurantOrUser(){
        return this.user.type === "restaurant" || this.user.type === "user";
    }
}