import React, {Component} from 'react';
import Start from '../../component/start.jsx';
import Form from '../../component/form.jsx';
import Funnel from '../../component/main/funnelWrap.jsx';
import NotFound from '../../component/notfound.jsx';
import EventWarp from '../../component/event/eventWarp.jsx';
import ProjectView from '../../component/project/projectView.jsx';
import ProjectList from '../../component/project/projectList.jsx';
import {Route, Switch} from 'react-router-dom';
import EventView from "../../component/event/eventView.jsx";
import EventForm from "../../component/event/eventForm.jsx"
import StatisticView from "../../component/statistic/statisticView.jsx"

class URLRouter extends Component {

    render() {
        return (
                <Switch>
                    <Route exact path="/" component={Form}/>
                    <Route path="/products" component={Start}/>
                    <Route path="/funnels" component={Funnel}/>
                    <Route path="/projects" component={ProjectList}/>
                    <Route path="/projectsView/:id_project" component={ProjectView}/>
                    <Route path="/events" component={EventWarp}/>
                    <Route path="/eventsView/:id_event" component={EventView}/>
                    <Route path="/eventForm" component={EventForm}/>
                    <Route path="/statistic" component={StatisticView}/>
                    <Route component={NotFound}/>
                </Switch>)
    }
}

export default URLRouter