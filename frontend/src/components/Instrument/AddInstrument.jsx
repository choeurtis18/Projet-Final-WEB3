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
        addInstrument(instrumentName).then(data => {
            setReturnMessage(data.messages);
        });
    }
  
    return (
        <div className="my-6 lg:flex md:flex">
          <span className=''>{returnMessage}</span>
          <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
            <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un instrument</h2>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom de l'instrument</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none"
                    type="text" id='instrumentName' onChange={handleChangeName} value={instrumentName}/>
            </div>
          </form>
        </div>    );
};
