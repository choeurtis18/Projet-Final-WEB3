import React from 'react'
import RegisterForm from '../../components/Register/RegisterForm'
import container from "../../assets/Container.png";
import halfBack from "../../assets/HalfBackground.png";
import {NavLink} from "react-router-dom";
import {BiArrowBack} from "react-icons/bi";

export default function Register() {
  return (
    <div>
      <div className="flex min-h-full login-page">
        <div className="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <NavLink to={"/"} className="text-mid_neutral text-sm back-breadcumb">
               <div className='flex flex-row gap-3 items-center'>
                  <BiArrowBack/>
                  <p>Retour à la page d'accueil  </p>
               </div>
        </NavLink>  
          <div className="mx-auto w-full max-w-sm lg:w-96">
            <div className=''>
              <p className="mt-8 text-sm leading-6 text-gray-500 subtitle-login">
                SALINE ROYAL ACADEMY
              </p>
              <h2 className="mt-2 text-[2.5rem] font-bold leading-9 tracking-tight text-gray-900 title-form ">Inscrivez-vous ! </h2>
              <p className="mt-6 text-sm leading-6 text-gray-500">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam dolor animi consectetur. Provident illum, minus odit  
              </p>
            </div>

            <div className="mt-10">
              <div>
                <RegisterForm/>
              </div>
            </div>
          </div>
        </div>
        <div className="relative hidden w-0 img-right-login lg:block">
          <div className="absolute inset-0 h-screen w-full object-cover flex items-center justify-center">
            <div className="w-200 h-200 bg-white img-superpose">
              <img className="w-200 h-200" src={container} alt="" />
            </div>
          </div>
          <img className="absolute inset-0 h-screen w-full object-cover" src={halfBack} alt="" />
        </div>
      </div>
    </div>
  )
}
