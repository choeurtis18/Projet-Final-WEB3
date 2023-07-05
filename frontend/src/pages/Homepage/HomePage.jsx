import React, { useEffect, useState } from "react";
import MasterclassQuizz from "../MasterclassDetails/MasterclassDetails";
import Nav from "../Nav/Nav";
import "./Homepage.css";
import prof from "../../assets/prof.png";

function Homepage() {
  const [masterclasses, setMasterclasses] = useState([]);
  const [selectedMasterclass, setSelectedMasterclass] = useState(null);

  useEffect(() => {
    fetch("http://localhost:8245/masterclassjson")
      .then((response) => response.json())
      .then((data) => setMasterclasses(data))
      .catch((error) => console.error(error));
  }, []);

  const handleMasterclassSelection = (masterclass) => {
    setSelectedMasterclass(masterclass);
  };

  return (
    <section>
      <div className="banner">
        <div className="banner-text">
          <h1>Saline Royale Academy</h1>
          <h6>Study with the world's best musicians!</h6>
        </div>
      </div>
      <div className="white-space"></div>
      <div className="formations">
        <div className="header">
          <h4 className="title-secondary">Un grand choix de masterclass</h4>
          <h6 className="subtitle">Subtitle</h6>
        </div>

        <div className="container-cards container">
          {masterclasses.map((masterclass) => (
            <div className="max-w-sm p-6  border rounded-lg shadow card-homepage ">
              <div className="card-header">
                <img src="https://placehold.co/46" alt="" />
                <a href="#">
                  <h5 className="mb-2 text-2xl font-bold tracking-tight">
                    {" "}
                    {masterclass.title}
                  </h5>
                </a>
              </div>

              <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {" "}
                {masterclass.description}{" "}
              </p>
              <a href={`/masterclass/${masterclass.id}`}>
                Lire plus
                <svg
                  aria-hidden="true"
                  className="w-4 h-4 ml-2 -mr-1"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fillRule="evenodd"
                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                    clipRule="evenodd"
                  ></path>
                </svg>
              </a>
            </div>
            // <li key={masterclass.id} onClick={() => handleMasterclassSelection(masterclass)}>
            //   {masterclass.title}
            // </li>
          ))}
        </div>

        <div className="full-container bg-secondary">
          <div className="header">
            <h4 className="title-tertiary">
              Des professeurs venus du monde entier
            </h4>
            <h6 className="subtitle-secondary">Subtitle</h6>
          </div>

          <div className="container">
            <div class="card">
              <img src={prof} alt="" />
              <div class="card-content">
                <h2>Miriem Fried</h2>
                <p>CEO & CO-Founder</p>
                <a href="#" class="button">
                  En savoir plus
                  <span class="">
                    <svg
                      aria-hidden="true"
                      className="w-4 h-4 ml-2 -mr-1"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fillRule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clipRule="evenodd"
                      ></path>
                    </svg>{" "}
                  </span>
                </a>
              </div>
            </div>
            <div class="card">
              <img src={prof} alt="" />
              <div class="card-content">
                <h2>Miriem Fried</h2>
                <p>CEO & CO-Founder</p>
                <a href="#" class="button">
                  En savoir plus
                  <span class="">
                    <svg
                      aria-hidden="true"
                      className="w-4 h-4 ml-2 -mr-1"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fillRule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clipRule="evenodd"
                      ></path>
                    </svg>{" "}
                  </span>
                </a>
              </div>
            </div>
            <div class="card">
              <img src={prof} alt="" />
              <div class="card-content">
                <h2>Miriem Fried</h2>
                <p>CEO & CO-Founder</p>
                <a href="#" class="button">
                  En savoir plus
                  <span class="">
                    <svg
                      aria-hidden="true"
                      className="w-4 h-4 ml-2 -mr-1"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fillRule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clipRule="evenodd"
                      ></path>
                    </svg>{" "}
                  </span>
                </a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  );
}

export default Homepage;
