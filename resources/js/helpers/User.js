import Token from './Token';
import AppStorage from './AppStorage';

class User {

    constructor() {

    }
  
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const user = res.data.user;
        
        if(Token.isValid(access_token)){
            AppStorage.store(user, access_token);
        }
    }

    hasToken(){
        const storedToken  = AppStorage.getToken();

        if(storedToken){
            return Token.isValid(storedToken) ? true : this.logout();
        }

        return false;
    }

    signedIn(){
        return this.hasToken();
    }

    logout(){
        AppStorage.flush();
    }

    name(){
        return this.get().name;
    }

    isAdmin(){
        return this.get().is_admin;
    }

    id(){
        // if(this.signedIn()){
        //     const payload = Token.payload(AppStorage.getToken());
            
        //     return payload.sub;
        // }
        return this.get().id;
    }

    get(){
        if(this.signedIn()){
            return JSON.parse(AppStorage.getUser());
        }
        return false;
    }

    own(id){
        return this.id() == id;
    }
}

export default User = new User();