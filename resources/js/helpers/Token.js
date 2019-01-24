class Token{

    constructor(){
        
    }

    isValid(token){
        const payload = this.payload(token);
        
        if(payload){
            //return payload.iss == App.loginUrl || App.signupUrl ? true : false;
            return payload.iss == 'http://lara/api/auth/login' || 'http://lara/api/auth/signup' ? true : false;
        }

        return false;
    }

    payload(token){
        const payload = token.split('.')[1];

        return this.decode(payload);
    }

    decode(payload){
        return JSON.parse(atob(payload));
    }

}

export default Token = new Token();