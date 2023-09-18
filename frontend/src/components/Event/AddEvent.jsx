import { useState } from "react";

import useAddEvent from "../../Hook/useAddEvent";

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
          <div className="mb-4">
            <h3 className="block text-sm font-medium mb-2">Nom de l'évènement</h3>
            <input className="shadow border rounded w-full p-3 focus:outline-none" type="text" id='eventName' onChange={handleChangeName} value={eventName}/>
          </div>
          <div className="mb-4">
            <h3 className="block text-sm font-medium mb-2">Description de l'évènement</h3>
            <input className="shadow border rounded w-full p-3 focus:outline-none" type="text" id='eventDescription' onChange={handleChangeDescription} value={eventDescription}/>
          </div>
          <div className="mb-4">
            <h3 className="block text-sm font-medium mb-2">Date de début de l'évènement</h3>
            <input className="shadow border rounded w-full p-3 focus:outline-none" type="datetime-local" id='eventDateStart' onChange={handleChangeDateStart} value={eventDateStart}/>
          </div>
          <div className="mb-4">
            <h3 className="block text-sm font-medium mb-2">Date de début de l'évènement</h3>
            <input className="shadow border rounded w-full p-3 focus:outline-none" type="datetime-local" id='eventDateEnd' onChange={handleChangeDateEnd} value={eventDateEnd}/>
          </div>
          <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded" type="submit" value="Enregistrer"/>
      </form>
    </div>    
  );
};
