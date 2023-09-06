// UpdateCurrentUser.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Cookies from 'js-cookie';
import jwtDecode from 'jwt-decode';
import useGetCurrentUser from "../../Hook/useGetCurrentUser"

function UpdateCurrentUserForm() {
    const [user, setUser] = useState([]);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');

    // Récupérez l'ID de l'utilisateur depuis le JWT
    const jwt = Cookies.get('token');
    let userId;

    if (jwt) {
        const decodedToken = jwtDecode(jwt);
        userId = decodedToken.id;
    }

    const getUser = useGetCurrentUser();


    useEffect(() => {
        // Récupérez les détails actuels de l'utilisateur
        Promise.all([
            getUser(userId),
        ]).then(([user]) => {
            setUser(user)
            setEmail(user.email)
        })
    }, [userId]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const response = await axios.put(`http://localhost:8245/users/${userId}/update`, {
                email: email,
                password: password
            }, {
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });
            setMessage("Informations mises à jour avec succès!");
        } catch (error) {
            console.error("Erreur lors de la mise à jour:", error);
            setMessage("Erreur lors de la mise à jour des informations.");
        }
    };

    return (
        <div>
            <h1>Mettre à jour les informations</h1>

            {message && <p>{message}</p>}

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Email:</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                </div>

                <div>
                    <label>Mot de passe (laissez vide pour ne pas changer):</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </div>

                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    );
}

export default UpdateCurrentUserForm;
