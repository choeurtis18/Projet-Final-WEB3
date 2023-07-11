export function LoginAction(jwt, id, email, roles, type) {
    return {
        jwt: jwt, 
        id: id,
        email: email,
        roles: roles,
        type: type
    }
}

export function LogoutAction() {
    return {
        type: 'LOGOUT'
    }
}