import React, {Component} from 'react';
import ItemPost from "./itemPost.jsx";

class FifthColumn extends Component {
    constructor(props) {
        super(props);
        this.state = {column : this.props.column};

    }

    render() {
        console.log(" fifth state", this.state);
        if (this.state.column.info.allModels.length > 0) {
            return (
                <ItemPost column={this.state.column.info.allModels}/>
            );
        }
        return <p></p>;
    }
}

export default FifthColumn;