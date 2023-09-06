import { useState } from "react";
import {useParams, useHistory} from "react-router-dom";

import useUpdateEvent from "../../Hook/useUpdateEvent";

const UpdateEvent = () => {
  const {id} = useParams();

  const [returnMessage, setReturnMessage] = useState('');
  const [eventName, setEventName] = useState('');
  
  const updateEvent = useUpdateEvent();
  
  const handleChangeName = (e) => {
    setEventName(e.target.value);
  }

  const history = useHistory();
  const handleSubmit = (e) => {
    e.preventDefault();
    updateEvent(eventName, id).then(data => {
      setReturnMessage(data.message);

      if(data.message == "Evenement modifié ! ") {
        history.push('/events', { replace: true });
      }
    });
  }

    return (
        <div className="w-full p-12">
          <span className=''>{returnMessage}</span>
          <h1 className='text-3xl mt-6 mb-1 font-medium text-primary_first font-black'>Modifier l'évènement</h1>
          <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom de l''événement'</h3>
              <div className="grid gap-y-4">
                <input className="shadow border rounded w-full p-3 focus:outline-none" required
                      type="text" id='instrumentName' onChange={handleChangeName} value={eventName}/>
                <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"type="submit" value="Enregistrer"/>
              </div>
            </div>
        </form>
        </div>
    );
};

export default UpdateEvent;
