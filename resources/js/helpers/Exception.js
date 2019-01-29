import User from './User';

class Exception {

    handle(error){
        if(error.response.status == 401){
            User.logout();
        }

        //this.isExpired(error.response.data.error);
    }

    isExpired(error){
        if(error == 'Token invalid'){
            User.logout();
        }
    }

}

export default Exception = new Exception();