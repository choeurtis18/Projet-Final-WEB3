import { useState } from "react";

import useAddEvent from "../../Hook/useAddEvent";
import Input from "../../components/Inputs/Input";

export default function AddEvent() {
  const [returnMessage, setReturnMessage] = useState('');
  const [eventName, setEventName] = useState('');
  const [eventDescription, setEventDescription] = useState('');
  const [eventDateStart, setEventDateStart] = useState('');
  const [eventDateEnd, setEventDateEnd] = useState('');
  const addEvent = useAddEvent();
  
  const handleChangeName = (e) => {
    setEventName(e.target.value);
  }
  const handleChangeDescription = (e) => {
    setEventDescription(e.target.value);
  }
  const handleChangeDateStart = (e) => {
    setEventDateStart(e.target.value);
  }
  const handleChangeDateEnd = (e) => {
    setEventDateEnd(e.target.value);
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    addEvent(eventName, eventDescription, eventDateStart, eventDateEnd).then(data => {
        setReturnMessage(data.message);
        if(data.message == "Nouvel événement ajouté") {
          history.push(`/events`);
        }
    });
  }

  return (
    <div className="p-6 flex flex-wrap">
      <span className=''>{returnMessage}</span>
      <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
        <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un événement</h2>
        <Input label="Nom de l'événement" type="text" onChange={handleChangeName} value={eventName} placeholder="Entrez le nom de l'événement"></Input>
        <Input label="Description de l'événement" type="text" onChange={handleChangeDescription} value={eventDescription} placeholder="Entrez la description de l'événement"></Input>
        <Input label="Date de début de l'événement" type="datetime-local" onChange={handleChangeDateStart} value={eventDateStart} placeholder=""></Input>
        <Input label="Date de fin de l'événement" type="datetime-local" onChange={handleChangeDateEnd} value={eventDateEnd} placeholder=""></Input>
        <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded" type="submit" value="Enregistrer"/>
      </form>
    </div>    
  );
};
