import { useState } from "react";

import useAddMasterclass from "../../Hook/useAddMasterclass";

export default function AddMasterclass() {
    const [returnMessage, setReturnMessage] = useState('');
    const [masterclassName, setMasterclassName] = useState('');
    const addMasterclass = useAddMasterclass();
    
    const handleChangeName = (e) => {
        setMasterclassName(e.target.value);
    }
  
    const handleSubmit = (e) => {
        addMasterclass(masterclassName).then(data => {
            setReturnMessage(data.messages);
        });
    }
  
    return (
        <div className="my-6 lg:flex md:flex">
          <span className=''>{returnMessage}</span>
          <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
            <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un Masterclass</h2>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom de la masterclass</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none"
                    type="text" id='masterclassName' onChange={handleChangeName} value={masterclassName}/>
            </div>
          </form>
        </div>    );
};
