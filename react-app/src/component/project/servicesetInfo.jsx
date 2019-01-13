import React, {Component} from 'react';


class ServicesetInfo extends Component {

    dateHandler(info, atribut) {
        var presult = '--'
        if(info[atribut] !== null) {
            presult = info[atribut];
        }
        return presult;
    }

    render() {
        if(this.props.info !== '') {

            return (
                <div>
                    <p>Дата оплаты: {this.dateHandler(this.props.info, 'payment')}</p>
                    <p>Дата поставки: {this.dateHandler(this.props.info, 'delivery')}</p>
                </div>
            );
        } else {
            return (
                <div></div>
            );
        }
    }

}

export default ServicesetInfo;