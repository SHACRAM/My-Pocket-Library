import {createBrowserRouter, RouterProvider} from 'react-router-dom'
import './App.css'
import {CreateAccount} from './Pages/CreateAccount'
import { Accueil } from './Pages/Accueil'
import { ConnectAccount } from './Pages/ConnectAccount'
import { MyAccount } from './Pages/MyAccount'
import { ModifyUserInfo } from './Pages/ModifyUserInfo'
import { ModifyPassword } from './Pages/ModifyPassword'
import { MyLibrary } from './Pages/MyLibrary'

const router = createBrowserRouter([

{
  path: '/Accueil',
  element: <Accueil />
},
{
  path: '/CreateAccount',
  element: <CreateAccount />
}
,
{
  path: '/ConnectAccount',
  element: <ConnectAccount />
},
{
  path: '/MyAccount',
  element: <MyAccount />
},
{
  path: '/ModifyUserInfo',
  element: <ModifyUserInfo />
},
{
  path: '/ModifyPassword',
  element: <ModifyPassword />
},
{
  path: '/MyLibrary',
  element: <MyLibrary />
}

])

function App() {

    return <RouterProvider router={router} />;
  
}

export default App
