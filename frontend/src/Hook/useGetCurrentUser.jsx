import Cookies from 'js-cookie';

export default function useGetCurrentUser() {
    const credentials = Cookies.get("token");

    return function (id) {
        return fetch(`http://localhost:8245/users/${id}`, {
            method: 'GET',
            credentials: 'include',
            mode: "cors",             
            headers: {
                'Authorization': `Bearer ${credentials}`
            },
        }).then(data => data.json())
    }
}