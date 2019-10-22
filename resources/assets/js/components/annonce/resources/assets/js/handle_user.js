import axios from 'axios';
var user_role = '';

export function get_connected_user_role(callback = null) {
    axios.get('/sentinel')
        .then((response) => {
            user_role = response.data.data.role_name ;
            if(callback!== null)
                callback();
        });
}

export function is_admin() {
    return user_role === 'Admin';
}

export function is_partenaire() {
    return user_role === 'Partenaire';
}

export function is_agent() {
    return user_role === 'Agent';
}

export function is_controlleur() {
    return user_role === 'Controleur';
}