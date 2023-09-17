// UpdateCurrentUser.js
import React, { useState, useEffect } from "react";
import axios from "axios";
import Cookies from "js-cookie";
import jwtDecode from "jwt-decode";
import useGetCurrentUser from "../../Hook/useGetCurrentUser";

function UpdateCurrentUserForm() {
  const [user, setUser] = useState([]);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");

  // Récupérez l'ID de l'utilisateur depuis le JWT
  const jwt = Cookies.get("token");
  let userId;

  if (jwt) {
    const decodedToken = jwtDecode(jwt);
    userId = decodedToken.id;
  }

  const getUser = useGetCurrentUser();

  useEffect(() => {
    // Récupérez les détails actuels de l'utilisateur
    Promise.all([getUser(userId)]).then(([user]) => {
      setUser(user);
      setEmail(user.email);
    });
  }, [userId]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.put(
        `http://localhost:8245/users/${userId}/update`,
        {
          email: email,
          password: password,
        },
        {
          headers: {
            Authorization: `Bearer ${jwt}`,
          },
        }
      );
      setMessage("Informations mises à jour avec succès!");
    } catch (error) {
      console.error("Erreur lors de la mise à jour:", error);
      setMessage("Erreur lors de la mise à jour des informations.");
    }
  };

  return (
    <div className="px-40">
      <h1 className="title-secondary pt-9 pb-9">
        Mettre à jour les informations
      </h1>

      {message && <p>{message}</p>}

      <form
        className="w-full max-w-sm form-user-update pb-9"
        onSubmit={handleSubmit}
      >
        <div className="md:flex md:items-center mb-6">
          <div className="md:w-1/3">
            <label
              className="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
              for="inline-full-name"
            >
              Email
            </label>
          </div>
          <div className="md:w-2/3">
            <input
              className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
              id="inline-full-name"
              type="text"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </div>
        </div>
        <div className="md:flex md:items-center mb-6">
          <div className="md:w-1/3">
            <label
              className="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
              for="inline-password"
            >
              Mot de passe (laissez vide pour ne pas changer):
            </label>
          </div>
          <div className="md:w-2/3">
            <input
              className="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
              id="inline-password"
              type="password"
              placeholder="******************"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </div>
        </div>

        <div className="md:flex md:items-center">
          <div className="md:w-1/3"></div>
          <div className="md:w-2/3">
            <button
              className="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded boutton-quizz"
              type="button"
            >
              Mettre à jour
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}

export default UpdateCurrentUserForm;
