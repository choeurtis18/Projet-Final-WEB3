import { useState } from "react";
import {useParams, useHistory} from "react-router-dom";

import useUpdateComposer from "../../Hook/useUpdateComposer";

export default function UpdateComposer() {
  const {id} = useParams();

  const [returnMessage, setReturnMessage] = useState('');
  const [composerName, setComposerName] = useState('');
  const [composerDescription, setComposerDescription] = useState('');
  const updateComposer = useUpdateComposer();
  
  const handleChangeName = (e) => {
    setComposerName(e.target.value);
  }
  const handleChangeDescription = (e) => {
    setComposerDescription(e.target.value);
  }

  const history = useHistory();
  const handleSubmit = (e) => {
    e.preventDefault();
    updateComposer(composerName, composerDescription, id).then(data => {
      setReturnMessage(data.message);

      if(data.message == "Composer Update") {
        history.push('/composers', { replace: true });
      }
    });
  }

  return (
    <div className="p-6 flex flex-wrap">
      <span className=''>{returnMessage}</span>
      <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
        <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Mettre à jour un Composer</h2>
        <div className="mb-4">
          <div className="grid gap-y-4">
            <div>
              <h3 className="block text-sm font-medium mb-2">Nom du Composer</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none" required
                    type="text" id='composerName' onChange={handleChangeName} value={composerName}/>
            </div>
            <div>
              <h3 className="block text-sm font-medium mb-2">Description du Composer</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none" required
                    type="text" id='composerDescription' onChange={handleChangeDescription} value={composerDescription}/>
            </div>
            <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                  type="submit" value="Enregistrer"/>
          </div>           
        </div>
      </form>
    </div> 
  );
};
