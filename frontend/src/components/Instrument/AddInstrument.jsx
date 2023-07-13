import { useState } from "react";

import useAddInstrument from "../../Hook/useAddInstrument";

export default function AddInstrument() {
  const [returnMessage, setReturnMessage] = useState('');
  const [instrumentName, setInstrumentName] = useState('');
  const addInstrument = useAddInstrument();
  
  const handleChangeName = (e) => {
    setInstrumentName(e.target.value);
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    addInstrument(instrumentName).then(data => {
      setReturnMessage(data.message);
    });
  }

  return (
    <div className="p-6 flex flex-wrap">
      <span className=''>{returnMessage}</span>
      <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
        <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un instrument</h2>
        <div className="mb-4">
          <h3 className="block text-sm font-medium mb-2">Nom de l'instrument</h3>
          <div className="grid gap-y-4">
            <input className="shadow border rounded w-full p-3 focus:outline-none"
                  type="text" id='instrumentName' onChange={handleChangeName} value={instrumentName}/>
            <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                  type="submit" value="Enregistrer"/>
          </div>
        </div>
      </form>
    </div>    
  );
};
