import { useState, useEffect } from "react";
import {useParams, useHistory} from "react-router-dom";

import Input from "../../components/Inputs/Input";
import useUpdateEvent from "../../Hook/useUpdateEvent";
import useGetEvent from "../../Hook/useGetEvent";

import moment from "moment";


const UpdateEvent = () => {
  const {id} = useParams();

  const [returnMessage, setReturnMessage] = useState('');
  const [eventName, setEventName] = useState('');
  const [eventDescription, setEventDescription] = useState('');
  const [eventDateStart, setEventDateStart] = useState('');
  const [eventDateEnd, setEventDateEnd] = useState('');
  
  const updateEvent = useUpdateEvent();
  const getEvent = useGetEvent();

  useEffect(() => {
    Promise.all([
      getEvent(id),
    ]).then(([event]) => {
      let dateStart = moment(event.event.date_start);
      let format_date_start = dateStart.format("YYYY-MM-DDThh:mm");
      let dateEnd = moment(event.event.date_end);
      let format_date_end = dateEnd.format("YYYY-MM-DDThh:mm");
      setEventName(event.event.name);
      setEventDescription(event.event.description);
      setEventDateStart(format_date_start);
      setEventDateEnd(format_date_end);
    })
  }, [id]);
  
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

  const history = useHistory();
  const handleSubmit = (e) => {
    e.preventDefault();
    updateEvent(eventName, eventDescription, eventDateStart, eventDateEnd, id).then(data => {
        setReturnMessage(data.message);
        if(data.message == "Event Update") {
          history.push(`/event/${id}`, { replace: true });
        }
    });
  }

    return (
    <div className="w-full p-12">
      <span className=''>{returnMessage}</span>
      <h1 className='text-3xl mt-6 mb-1 font-medium text-primary_first font-black'>Modifier l'évènement</h1>

      <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
        <Input label="Nom de l'événement" type="text" onChange={handleChangeName} value={eventName} placeholder="Entrez le nom de l'événement"></Input>
        <Input label="Description de l'événement" type="text" onChange={handleChangeDescription} value={eventDescription} placeholder="Entrez la description de l'événement"></Input>
        <Input label="Date de début de l'événement" type="datetime-local" onChange={handleChangeDateStart} value={eventDateStart} placeholder=""></Input>
        <Input label="Date de fin de l'événement" type="datetime-local" onChange={handleChangeDateEnd} value={eventDateEnd} placeholder=""></Input>
        <button type="submit">Confirmer</button>
      </form>
    </div>
    );
};

export default UpdateEvent;
