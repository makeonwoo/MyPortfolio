#1.선수중 유효슈팅/슈팅 비율이 높은 상위10명의 선수들이 소속된 리그와 팀
select l.league_name ,o.own_team_name, o.player_name,p.season, p.target_shot / p.shot 
	as "슛 정확도"
	from own_team as o,player as p, league as l where o.player_name = p.player_name 	and o.own_team_season = p.season and o.own_team_name = l.team 
	and o.own_team_season = l.season order by p.target_shot / p.shot desc limit 10

#2. 리그에 승격된 팀의 away경기장 경기 승률 
SELECT  count(r.away_win)/t.game_number_team*100 as 승률,t.team_name ,t.team_season
	FROM team as t , record as r , league as l
    	where r.away = t.team_name and r.record_season = t.team_season and 
	r.away_win = "승리팀" and t.team_name = l.team and t.team_season = l.season and 	l.promotion ="승격" group by team_name,team_season	
	order by count(r.away_win)/t.game_number_team*100 desc;

#3. HOME팀에서 주말에 플레이햇을때 팀의 성적이 높은 10명의 팀과 소속리그
select l.league_name,r.home,r.record_season,count(*) as "home_주말 승리",t.game_number_team as "참여 경기수" from record as r,team as t ,league as l
	where (r.record_date like '%토%' or r.record_date like '%일%') and r.home_win = '승리팀' and r.home =t.team_name and r.record_season = t.team_season
	and t.team_name = l.team and t.team_season = l.season
    group by home,record_season
    order by count(*) desc limit 10;
    
#4. 경고(파울,경고,퇴장)를 받은 선수의 팀과 팀의 승점을 상위 10명을 표시
SELECT p.player_name, p.season, o.own_team_name ,p.foul+p.warning+p.player_exit as "경고!", t.winning_point 
    FROM player as p , own_team as o , team as t where p.player_name = o.player_name and p.season = o.own_team_season
	and o.own_team_name = t.team_name and o.own_team_season = t.team_season
    order by p.foul+p.warning+p.player_exit desc limit 10;