import { useEffect } from 'react';

const useGetMasterclasses = () => {
  useEffect(() => {
    const fetchMasterclasses = async () => {
      try {
        const response = await fetch('http://localhost:8245/masterclassesjson');
        if (!response.ok) {
          throw new Error('Failed to fetch masterclasses');
        }
        const masterclasses = await response.json();
        // Enregistrer les masterclasses dans un fichier (par exemple, "masterclasses.json") dans le dossier "hooks" du frontend
        const fileData = JSON.stringify(masterclasses);
        const fileBlob = new Blob([fileData], { type: 'application/json' });
        const fileUrl = URL.createObjectURL(fileBlob);
        const link = document.createElement('a');
        link.href = fileUrl;
        link.download = 'masterclasses.json';
        link.click();
      } catch (error) {
        console.error(error);
      }
    };

    fetchMasterclasses();
  }, []);
};

export default useGetMasterclasses;
