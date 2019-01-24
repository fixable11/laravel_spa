import Token from './Token';
import AppStorage from './AppStorage';

class User {

    constructor() {
      
    }
  
    login(formData) {
        axios.post('/api/auth/login', formData)
        .then((res) => {
            this.responseAfterLogin(res);
        })
        .catch((error) => {
            //flash(error.response.data.error, 'error');
            console.dir(error);
        });
    }

    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const username = res.data.user;
        
        if(Token.isValid(access_token)){
            AppStorage.store(username, access_token);
        }
    }

    hasToken(){
        const storedToken  = AppStorage.getToken();

        if(storedToken){
            return Token.isValid(storedToken) ? true : false;
        }

        return false;
    }

    signedIn(){
        return this.hasToken;
    }

    logout(){
        AppStorage.flush();
    }

    name(){
        if(this.signedIn){
            return AppStorage.getUser();
        }
    }

    name(){
        if(this.signedIn){
            const payload = Token.payload(AppStorage.getToken());
            
            return payload.sub;
        }
    }
}

export default User = new User();