import React, {Component} from 'react';
import ItemPost from './itemPost.jsx';
import FirstColumn from './firstColumn.jsx';
import SecondColumn from './secondColumn.jsx';
import ThirdColumn from './thirdColumn.jsx';
import FourthColumn from './fourthСolumn.jsx';
import FifthColumn from './fifthColumn.jsx';
import SixthColumn from './sixthColumn.jsx';
import {Link, BrowserRouter} from 'react-router-dom';

const API = '/api/funnels';

class Funnel extends Component {
    constructor(props) {
        super(props);
        this.state = {data: ''};
    }

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({data: data}))
            .catch((error) => {
                console.error(error);
            });
    }

    render() {
        console.log("wrap", this.state)
        if (this.state.data !== '') {
            return (
                <div>
                    <SecondColumn column={this.state.data[1]}/>
                </div>
            )
        } else {
            return (<p>do not render</p>);
        }
    }
}

export default Funnel;