import React from "react";
import "./Pricing.css";
import {BsFillPatchCheckFill} from "react-icons/bs";

const PricingCard = ({ title, price, access, frequency,interviews, annotation,angle }) => {
  return (
    <div className="PricingCard">
      <header>
        <p className="card-title">{title}</p>
        <h1 className="card-price">{price}€ <span>/Mois</span></h1>
      </header>
      <div className="card-features">
        <div className="card-access item">
            <div className="icon"><BsFillPatchCheckFill/></div>
            <div className="text">{access} access to all our masterclasses.</div>
        </div>
        {frequency &&(
        <div className="card-frequency item">
            <div className="icon"><BsFillPatchCheckFill/></div>
            <div className="text">De nouvelles vidéos sont disponibles {frequency}.</div>
        </div>
        )}
        {interviews && ( 
        <div className="card-frequency item">
            <div className="icon"><BsFillPatchCheckFill/></div>
            <div className="text"> Des interviews exclusives {interviews}.</div>
        </div>
        )}
        {annotation &&(
        <div className="card-annotation item">
            <div className="icon"><BsFillPatchCheckFill/></div>
            <div className="text">Partitions annotées par nos {annotation} et prêtes à être téléchargées.</div>
        </div>
        )}
        {angle &&(
        <div className="card-angle item">
            <div className="icon"><BsFillPatchCheckFill/></div>
            <div className="text">{angle} angle videos available in HD on all your devices.</div>
        </div>
        )}

      </div>
      <button className="card-btn">Commencer</button>
    </div>
  );
};

export default PricingCard;
