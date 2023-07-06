import { useState } from "react";

import useAddComposer from "../../Hook/useAddComposer";

export default function AddComposer() {
    const [returnMessage, setReturnMessage] = useState('');
    const [composerName, setComposerName] = useState('');
    const [composerDescription, setComposerDescription] = useState('');
    const addComposer = useAddComposer();
    
    const handleChangeName = (e) => {
      setComposerName(e.target.value);
    }
    const handleChangeDescription = (e) => {
      setComposerDescription(e.target.value);
    }
  
    const handleSubmit = (e) => {
      addComposer(ComposerName, composerDescription).then(data => {
        setReturnMessage(data.messages);
      });
    }
  
    return (
        <div className="my-6 lg:flex md:flex">
          <span className=''>{returnMessage}</span>
          <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
            <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Ajoutez un Composer</h2>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom du Composer</h3>
              <div className="grid gap-y-4">
                <input className="shadow border rounded w-full p-3 focus:outline-none"
                      type="text" id='composerName' onChange={handleChangeName} value={composerName}/>
                <input className="shadow border rounded w-full p-3 focus:outline-none"
                      type="text" id='composerDescription' onChange={handleChangeDescription} value={composerDescription}/>
              </div>           
            </div>
          </form>
        </div>    );
};
