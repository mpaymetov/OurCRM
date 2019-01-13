import React, {Component} from 'react';
import Start from './component/start.jsx';
import Form from './component/form.jsx';
import TopMenu from './component/topMenu.jsx';
import Funnel from './component/main/funnelWrap.jsx';
import NotFound from './component/notfound.jsx';
import Nav from './component/nav/Nav.jsx';
import EventWarp from './component/event/eventWarp.jsx';
import ProjectView from './component/project/projectView.jsx'
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';
import EventView from "./component/event/eventView.jsx";
import EventForm from "./component/event/eventForm.jsx"
import TopWrap from "./component/nav/topWrap.jsx";


class App extends Component {

    render() {
        return (
            <div className="wrap">
                <div className="container">
                    <TopWrap/>
                </div>
            </div>
        );
    }
}

export default App;

