export const teamColors: Record<string, string> = {
    red_bull: '#3671C6',
    ferrari: '#E8002D',
    mercedes: '#27F4D2',
    mclaren: '#FF8000',
    aston_martin: '#229971',
    alpine: '#FF87BC',
    williams: '#64C4FF',
    rb: '#6692FF',
    haas: '#B6BABD',
    sauber: '#52E252',
    audi: '#D40000',
    cadillac: '#00543C',
};

export function teamColor(ref: string): string {
    return teamColors[ref] ?? '#7A818C';
}