import { useState, useEffect } from "react";
import {useParams, useHistory} from "react-router-dom";
import Select from 'react-select'

import useGetInstrumentList from "../../Hook/useGetInstrumentList";
import useGetComposerList from "../../Hook/useGetComposerList";
import useUpdateMasterclass from "../../Hook/useUpdateMasterclass";

export default function UpdateMasterclass() {
  const {id} = useParams();

  const [returnMessage, setReturnMessage] = useState('');
  const [masterclassTitle, setMasterclassTitle] = useState('');
  const [masterclassDescription, setMasterclassDescription] = useState('');
  const [masterclassCertification, setMasterclassCertification] = useState('');
  const [masterclassInstrument, setMasterclassInstrument] = useState('');
  const [masterclassComposer, setMasterclassComposer] = useState('');
  const updateMasterclass = useUpdateMasterclass();
  
  const handleChangeTitle = (e) => {
    setMasterclassTitle(e.target.value);
  }
  const handleChangeDescription = (e) => {
    setMasterclassDescription(e.target.value);
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    updateMasterclass(masterclassTitle, masterclassDescription, masterclassCertification.value, 
      masterclassInstrument.value, masterclassComposer.value, id).then(data => {
        setReturnMessage(data.message);
    });
  }

  const optionsCertification = [
    { value: 'Débutant', label: 'Débutant' },
    { value: 'Intérmédiaire', label: 'Intérmédiaire' },
    { value: 'Avancé', label: 'Avancé' }
  ]

  const [instrumentList, setInstrumentList] = useState([]);
  const [composerList, setComposerList] = useState([]);
  const getInstrumentList = useGetInstrumentList();
  const getComposerList = useGetComposerList();

  useEffect(() => {
    getInstrumentList().then(data => {
      setInstrumentList(data.instruments);
    });

    getComposerList().then(data => {
      setComposerList(data.composers);
    });
  }, []);

  var optionsInstrument = [];
  instrumentList.forEach(element => {
    optionsInstrument.push({ value: element.id, label: element.name})
  })
  var optionsComposer = [];
  composerList.forEach(element => {
    optionsComposer.push({ value: element.id, label: element.name})
  })



  return (
    <div className="p-6 flex flex-wrap">
      <span className=''>{returnMessage}</span>
      <form className='bg-white w-full shadow-shadow_3 rounded px-6 py-2' onSubmit={handleSubmit}>
        <h2 htmlFor='message' className='my-2 form-label text-xl font-black'>Mettre à jour une Masterclass</h2>
        <div className="mb-4">
          <div className="grid gap-y-4">
            <div>
              <h3 className="block text-sm font-medium mb-2">Nom de la masterclass</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none" required
                    type="text" id='masterclassTitle' onChange={handleChangeTitle} value={masterclassTitle}/>
            </div>
            <div>
              <h3 className="block text-sm font-medium mb-2">Description de la masterclass</h3>
              <input className="shadow border rounded w-full p-3 focus:outline-none" required
                    type="text" id='masterclassDescription' onChange={handleChangeDescription} value={masterclassDescription}/>
            </div>
            <div>
              <h3 className="block text-sm font-medium mb-2">Certification</h3>
              <Select options={optionsCertification} defaultValue={"standard"} required
                      onChange={(masterclassCertification) => setMasterclassCertification(masterclassCertification)}
              />
            </div>
            <div>
              <h3 className="block text-sm font-medium mb-2">Instrument</h3>
              <Select options={optionsInstrument} defaultValue={"standard"} required
                      onChange={(masterclassInstrument) => setMasterclassInstrument(masterclassInstrument)}
              />
            </div>
            <div>
              <h3 className="block text-sm font-medium mb-2">Compositeurs</h3>
              <Select options={optionsComposer} defaultValue={"standard"} required
                      onChange={(masterclassComposer) => setMasterclassComposer(masterclassComposer)}
              />
            </div>
            <input className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                  type="submit" value="Enregistrer"/>
          </div>
        </div>
      </form>
    </div>      
  );
};
