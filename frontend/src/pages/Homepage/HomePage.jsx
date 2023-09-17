import React, { useEffect, useState } from "react";
import "./Homepage.css";
import prof from "../../assets/prof.png";
import prof1 from "../../assets/prof6.jpg";
import prof2 from "../../assets/prof7.jpg";
import prof3 from "../../assets/prof3.jpg";
import vignetteMasterclass from "../../assets/vignette.png";
import Partner from "../../components/Partner/Partner";
import PricingCard from "../../components/Pricing/Pricing";
import ProfessorCard from "../../components/ProfessorCard/ProfessorCard";


function Homepage() {
  const [masterclasses, setMasterclasses] = useState([]);
  const [selectedMasterclass, setSelectedMasterclass] = useState(null);

  useEffect(() => {
    fetch("http://localhost:8245/masterclassjson")
      .then((response) => response.json())
      .then((data) => setMasterclasses(data))
      .catch((error) => console.error(error));

  }, []);

  const getRandomMasterclasses = () => {
    const numberOfRandomMasterclasses = 4;
    
    if (masterclasses.length < numberOfRandomMasterclasses) {
      return masterclasses;
    }

    const randomMasterclasses = [];
    const masterclassIndices = [...Array(masterclasses.length).keys()];

    while (randomMasterclasses.length < numberOfRandomMasterclasses) {
      const randomIndex = Math.floor(Math.random() * masterclassIndices.length);
      const selectedIndex = masterclassIndices.splice(randomIndex, 1)[0];
      randomMasterclasses.push(masterclasses[selectedIndex]);
    }

    return randomMasterclasses;
  };

  const handleMasterclassSelection = (masterclass) => {
    setSelectedMasterclass(masterclass);
  };
  
  const randomMasterclasses = getRandomMasterclasses();


  return (
    <section>
      <div className="banner">
        <div className="banner-text">
          <h1>Saline Royale Academy</h1>
          <h6>Étudier avec les meilleurs musiciens du monde !</h6>
        </div>
      </div>
      <div className="masterclasses section-container">
        <div className="header">
          <h4 className="title-secondary">Un grand choix de masterclass</h4>
          <h6 className="subtitle">Subtitle</h6>
        </div>

        <div className="container-cards  ">
        {randomMasterclasses.map((masterclass, index) => (
            <div key={index} className="max-w-sm p-6   rounded-lg shadow card-homepage ">
              <div className="card-header">
                <img src={vignetteMasterclass} alt="" />
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
                En savoir plus
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
      </div>
      <div className="full-container bg-secondary">
          <div className="header">
            <h4 className="title-tertiary">
              Des professeurs venus du monde entier
            </h4>
            <h6 className="subtitle-secondary">Subtitle</h6>
          </div>

          <div className="container-prof">
            <ProfessorCard
              name="Clive Greensmith"
              title="Professeur a Colburn School"
              imageSrc={prof2} 
            />
            <ProfessorCard
              name="Phillips-Varjabédian"
              title="Professeur au CNSM de Paris"
              imageSrc={prof3} 
            />
            <ProfessorCard
              name="Sharon Kam"
              title="clarinettistes solo international"
              imageSrc={prof1} 
            />
             <ProfessorCard
              name="Miriem Fried"
              title="Professeur de violoncelle"
              imageSrc={prof} 
            />
              
            
          </div>
        </div>
        <div className="masterclasses section-container">
        <div className="header">
          <h4 className="title-secondary">Un grand choix de formations</h4>
          <h6 className="subtitle">Subtitle</h6>
        </div>

        <div className="container-cards  ">
        {randomMasterclasses.map((masterclass, index) => (
            <div key={index} className="max-w-sm p-6   rounded-lg shadow card-homepage ">
              <div className="card-header">
                <img src={vignetteMasterclass} alt="" />
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
                En savoir plus
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
      </div>
      <div className="partners section-container">
        <div className="header">
          <h4 className="title-secondary title-partners">Nos centres de formation partenaires  </h4>
        </div>

        <div className="container-cards  ">
           
            <Partner />
        </div>
      </div>
      <div className="pricing section-container-pricing">
        <div className="header header-pricing">
          <h4 className="title-secondary">Nos offres d'abonnement   </h4>
        </div>

        <div className="container-cards  pricing-cards">
            <PricingCard
            title="Essai gratuit"
            price={ "0"}
            angle={"Multi"}
            />
            <PricingCard
            title="Abonnement annuel"
            price={ "15.9"}
            angle={"Multi"}
            frequency={"chaque mois"}
            interviews={"avec les plus grands professeurs du monde"}
            annotation={"professeurs"}
            />
            <PricingCard
            title="Abonnement mensuel"
            price={ "19.8"}
            frequency={"chaque mois"}
            interviews={"avec les plus grands professeurs du monde"}
            angle={"Multi"}
            annotation={"professeurs"}
            />
        </div>
      </div>
    </section>
  );
}

export default Homepage;
