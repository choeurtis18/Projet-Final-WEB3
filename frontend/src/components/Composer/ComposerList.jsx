import { useState, useEffect } from "react";
//import {NavLink} from "react-router-dom";

import useGetComposerList from "../../Hook/useGetComposerList";
import useAddComposer from "../../Hook/useAddComposer";

const ComposerList = () => {
  const [composerList, setComposerList] = useState([]);

  const getComposerList = useGetComposerList();

  useEffect(() => {
    getComposerList().then(data => {
      setComposerList(data.composers);
    });
  }, [])


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
      addComposer(composerName, composerDescription).then(data => {
          setReturnMessage(data.messages);
      });
  }

  return (
    <div>
        <h1 className='text-3xl m-5 text-center'>Composers</h1>
        <div className="flex flex-col my-4 lg:flex md:flex">
          <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
            {
              composerList.map((composer, index) => (
                <div className="border border-gray-200 rounded-lg p-4 w-full" key={index}>
                  <h3 className="text-xl font-bold">{composer.name}</h3>
                  <p>{composer.description}</p>
                </div>  
                /*
                  <NavLink key={index} to={`/composer/${composer.id}`}
                              className='text-black text-decoration-none w-100 d-block text-center 10'>
                      {composer.name}
                  </NavLink>
                */
              ))
            }

          </div>     
        </div>

        <div className="my-6 lg:flex md:flex">
          <span className=''>{returnMessage}</span>
          <form className='bg-white w-full shadow-md rounded p-6' onSubmit={handleSubmit}>
            <h2 htmlFor='message' className='my-2 form-label text-xl font-bold'>Ajoutez un compositeur</h2>
            <div className="mb-4">
              <h3 className="block text-sm font-medium mb-2">Nom du compositeur</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none"
                    type="text" id='compositeurName' onChange={handleChangeName} value={composerName}/>
            </div>
            <div className="mb-6">
              <h3 className="block text-sm font-medium mb-2">Description du compositeur</h3>
              <input className="shadow border rounded w-full h-full p-3 focus:outline-none"
                    type="text" id='compositeurDescription' onChange={handleChangeDescription} value={composerDescription}/>
            </div>
          </form>
        </div>
    </div>
  );
};

export default ComposerList;
