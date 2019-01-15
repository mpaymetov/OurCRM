import React, {Component} from 'react';
import {BrowserRouter, Route, Switch, Link, NavLink} from 'react-router-dom';
import EventView from "./EventView.jsx";


class ItemEvent extends Component {
    constructor(props) {
        super(props);
        this.state =
            {hits: this.props};
    }

    render() {
        console.log(this.state.hits);
        if (this.props.hits !== '') {
            return (
                <div className="container back">

                    {this.props.items.map((hits) => //todo попробовать вынести в функцию
                        <div className="panel-body post panel">
                            <div className="col-md-6">
                                <p className="post_number">номер события:{hits.id_event || ''}</p>
                                <h5>{hits.message || ''}</h5>
                                <h6>{hits.id_user}</h6>
                            </div>
                            <nav>
                                <Link to={"/eventsView/" + hits.id_event}> подробнее </Link>
                            </nav>
                        </div>
                    )}
                </div>
            )
        } else {
            return (<p>do not render</p>);
        }

    }
}

export default ItemEvent;